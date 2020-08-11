import { mergeMap, map, catchError } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import Cookie from 'js-cookie';
import { processCheckout, REQUEST_CHECKOUT, CHECKOUT_FAIL, requestCreateQuote } from '../actions/productActions';
import { toast } from 'react-toastify';

const quoteIdEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_CHECKOUT),
		mergeMap(() => {
			const quoteId = Cookie.get('quoteId');
			const paramCheckout = {
				paymentMethod: {
					method: 'checkmo',
				},
				addressInformation: {
					shipping_address: {
						region: 'New York',
						region_id: 43,
						region_code: 'NY',
						country_id: 'US',
						street: ['123 Oak Ave'],
						postcode: '10577',
						city: 'Purchase',
						firstname: 'Jane',
						lastname: 'Doe',
						email: 'jdoe@example.com',
						telephone: '512-555-1111',
					},
					billing_address: {
						region: 'New York',
						region_id: 43,
						region_code: 'NY',
						country_id: 'US',
						street: ['123 Oak Ave'],
						postcode: '10577',
						city: 'Purchase',
						firstname: 'Jane',
						lastname: 'Doe',
						email: 'jdoe@example.com',
						telephone: '512-555-1111',
					},
					shipping_carrier_code: 'tablerate',
					shipping_method_code: 'bestway',
				},
				email: 'jdoe@example.com',
			};

			const API_CHECKOUT = `http://localhost:80/quochuy/rest/V1/cartPOS/${quoteId}/checkout`;

			return ajax.post(API_CHECKOUT, JSON.stringify(paramCheckout), { 'Content-Type': 'application/json' }).pipe(
				map((response) => {
					const status = response && response.status === 200;
					if (status) {
						toast.success('Checkout Success!', {
							position: toast.POSITION.TOP_CENTER,
						});
						Cookie.remove('quoteId');
						return requestCreateQuote();
					} else {
						return processCheckout(CHECKOUT_FAIL, '');
					}
				}),
				catchError((error) => {
					return processCheckout(CHECKOUT_FAIL, error);
				})
			);
		})
	);
export default quoteIdEpic;
