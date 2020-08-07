import { mergeMap, map } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import {
	processAuthenticateUser,
	AUTHENTICATED,
	NOT_AUTHENTICATED,
	REQUEST_AUTHENTICATE_USER,
} from '../actions/loginActions';

const API_HOST = `http://localhost:80/quochuy/rest/V1/staff/login`;

const loginEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_AUTHENTICATE_USER),
		mergeMap(({ payload }) =>
			ajax.post(API_HOST, payload, { 'Content-Type': 'application/json' }).pipe(
				map((response) => {
					// console.log(response);
					const status =
						response.status === 200 &&
						response &&
						response.response &&
						response.response[0] &&
						response.response[0].status === true;
					if (!status) {
						return processAuthenticateUser(NOT_AUTHENTICATED, response.response);
					} else {
						return processAuthenticateUser(AUTHENTICATED, response.response);
					}
				})
			)
		)
	);
export default loginEpic;
