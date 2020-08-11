import { mergeMap, map, catchError } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import Cookie from 'js-cookie';
import {
	processCreateQuote,
	REQUEST_CREATE_QUOTE,
	CREATE_QUOTE_SUCCESS,
	CREATE_QUOTE_FAIL,
} from '../actions/productActions';

const API_CREATE_QUOTE = 'http://localhost:80/quochuy/rest/V1/guest-carts';

const quoteIdEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_CREATE_QUOTE),
		mergeMap(() => {
			return ajax.post(API_CREATE_QUOTE).pipe(
				map((response) => {
					const status = response && response.status === 200;
					if (status) {
						Cookie.set('quoteId', response.response);
						return processCreateQuote(CREATE_QUOTE_SUCCESS, response.response);
					} else {
						return processCreateQuote(CREATE_QUOTE_FAIL, '');
					}
				}),
				catchError((error) => {
					return processCreateQuote(CREATE_QUOTE_FAIL, error);
				})
			);
		})
	);
export default quoteIdEpic;
