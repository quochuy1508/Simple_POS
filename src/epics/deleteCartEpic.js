import { mergeMap, map, catchError } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import {
	processDeleteCart,
	REQUEST_DELETE_CART,
	DELETE_CART_SUCCESS,
	DELETE_CART_FAIL,
} from '../actions/productActions';
import Cookie from 'js-cookie';

const deleteCartEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_DELETE_CART),
		mergeMap(({ payload }) => {
			console.log('payload: ', payload);
			const quoteId = Cookie.get('quoteId');

			const API_HOST = `http://localhost:80/quochuy/rest/V1/cartPOS/` + quoteId + '/items/' + payload.id;

			return ajax.delete(API_HOST).pipe(
				map((response) => {
					console.log('response: ', response);
					const status = response && response.status === 200;
					if (status) {
						return processDeleteCart(DELETE_CART_SUCCESS, payload.id);
					} else {
						return processDeleteCart(DELETE_CART_FAIL, null);
					}
				}),
				catchError((error) => {
					console.log('error: ', error);
				})
			);
		})
	);
export default deleteCartEpic;
