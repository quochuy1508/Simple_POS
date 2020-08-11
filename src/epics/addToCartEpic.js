import { mergeMap, map, catchError } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import { processAddToCart, REQUEST_ADD_TO_CART, ADD_TO_CART_SUCCESS } from '../actions/productActions';
import Cookie from 'js-cookie';

const addToCartEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_ADD_TO_CART),
		mergeMap(({ payload }) => {
			const quoteId = Cookie.get('quoteId');
			const addCartBody = {
				cartItem: {
					sku: payload.sku,
					qty: 1,
					quote_id: quoteId,
					product_option: payload.product_option ? payload.product_option : null,
					extension_attributes: {},
				},
			};

			const API_HOST = `http://localhost:80/quochuy/rest/V1/cartPOS/` + quoteId + '/items';

			return ajax.post(API_HOST, addCartBody, { 'Content-Type': 'application/json' }).pipe(
				map((response) => {
					const status = response && response.status === 200;
					if (status) {
						return processAddToCart(ADD_TO_CART_SUCCESS, response.response);
					} else {
						return processAddToCart(ADD_TO_CART_SUCCESS, []);
					}
				}),
				catchError((error) => {
					return processAddToCart(ADD_TO_CART_SUCCESS, [error]);
				})
			);
		})
	);
export default addToCartEpic;
