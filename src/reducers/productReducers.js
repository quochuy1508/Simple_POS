import { GET_PRODUCT_SUCCESS, GET_PRODUCT_FAIL } from '../actions/productActions';

const products = (state = {}, action) => {
	switch (action.type) {
		case GET_PRODUCT_SUCCESS:
			return {
				...state,
				products: action.products,
			};
		case GET_PRODUCT_FAIL:
			return {
				...state,
				products: [],
			};

		default:
			return state;
	}
};

export default products;
