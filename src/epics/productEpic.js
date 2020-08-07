import { mergeMap, map } from 'rxjs/operators';
import { ajax } from 'rxjs/ajax';
import { ofType } from 'redux-observable';
import {
	processGetProduct,
	GET_PRODUCT_SUCCESS,
	GET_PRODUCT_FAIL,
	REQUEST_GET_PRODUCT,
} from '../actions/productActions';

const API_HOST = `http://localhost:80/quochuy/rest/V1/staff/product`;

const productEpic = (action$) =>
	action$.pipe(
		ofType(REQUEST_GET_PRODUCT),
		mergeMap(({ payload }) => {
			// console.log('payload: ', payload);
			return ajax(
				API_HOST +
					'?searchCriteria[filter_groups][0][filters][0][field]=webpos_visible&' +
					'searchCriteria[filter_groups][0][filters][0][value]=1&' +
					'searchCriteria[filter_groups][0][filters][0][condition_type]=eq&' +
					'searchCriteria[filter_groups][1][filters][0][field]=type_id&' +
					'searchCriteria[filter_groups][1][filters][0][value]=simple&' +
					'searchCriteria[filter_groups][1][filters][0][condition_type]=eq&' +
					'searchCriteria[filter_groups][1][filters][1][field]=type_id&' +
					'searchCriteria[filter_groups][1][filters][1][value]=configurable&' +
					'searchCriteria[filter_groups][1][filters][0][condition_type]=eq&' +
					'searchCriteria[filter_groups][2][filters][0][field]=name&' +
					`searchCriteria[filter_groups][2][filters][0][value]=${(payload &&
						payload.type === 'name' &&
						'%25' + payload.value + '%25') ||
						'%25%25'}&` +
					'searchCriteria[filter_groups][2][filters][0][condition_type]=like&' +
					'searchCriteria[filter_groups][3][filters][0][field]=sku&' +
					`searchCriteria[filter_groups][3][filters][0][value]=${(payload &&
						payload.type === 'sku' &&
						'%25' + payload.value + '%25') ||
						'%25%25'}&` +
					'searchCriteria[filter_groups][3][filters][0][condition_type]=like&' +
					'searchCriteria[pageSize]=16&' +
					`searchCriteria[currentPage]=${payload.currentPage || 1}`
			).pipe(
				map((response) => {
					// console.log('response: ', response);
					if (response.status === 200) {
						return processGetProduct(GET_PRODUCT_SUCCESS, response.response);
					} else {
						return processGetProduct(GET_PRODUCT_FAIL, {});
					}
				})
			);
		})
	);
export default productEpic;
