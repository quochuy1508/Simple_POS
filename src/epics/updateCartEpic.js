import { mergeMap, map, catchError } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import {
	processUpdateCart,
	REQUEST_UPDATE_CART,
	UPDATE_CART_SUCCESS,
	UPDATE_CART_FAIL,
} from '../actions/productActions';
import Cookie from 'js-cookie';

const updateCartEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_UPDATE_CART),
		mergeMap(({ payload }) => {
			console.log('payload: ', payload);
			const quoteId = Cookie.get('quoteId');
			const updateCartBody = {
				cartItem: {
					sku: payload.sku,
					qty: payload.qty,
					quote_id: quoteId,
				},
			};

			const API_HOST = `http://localhost:80/quochuy/rest/V1/cartPOS/` + quoteId + '/items/' + payload.id;

			return ajax.put(API_HOST, updateCartBody, { 'Content-Type': 'application/json' }).pipe(
				map((response) => {
					console.log('response: ', response);
					const status = response && response.status === 200;
					if (status) {
						return processUpdateCart(UPDATE_CART_SUCCESS, response.response);
					} else {
						return processUpdateCart(UPDATE_CART_FAIL, []);
					}
				}),
				catchError((error) => {
					console.log('error: ', error);
				})
			);
		})
	);
export default updateCartEpic;
