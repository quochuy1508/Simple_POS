import { mergeMap, map, catchError } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import { processGetCart, REQUEST_GET_CART, GET_CART_SUCCESS } from '../actions/productActions';
import Cookie from 'js-cookie';

const getCartEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_GET_CART),
		mergeMap(() => {
			const quoteId = Cookie.get('quoteId');
			const API_HOST = `http://localhost:80/quochuy/rest/V1/cartPOS/` + quoteId + '/items';

			return ajax.get(API_HOST).pipe(
				map((response) => {
					// console.log('response: ', response);
					const status = response && response.status === 200;
					if (status) {
						return processGetCart(GET_CART_SUCCESS, response.response);
					} else {
						return processGetCart(GET_CART_SUCCESS, []);
					}
				}),
				catchError((error) => {
					return processGetCart(GET_CART_SUCCESS, [error]);
				})
			);
		})
	);
export default getCartEpic;
