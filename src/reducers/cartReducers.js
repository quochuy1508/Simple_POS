import {
	ADD_TO_CART_SUCCESS,
	ADD_TO_CART_FAIL,
	GET_CART_SUCCESS,
	CHECKOUT_SUCCESS,
	CREATE_QUOTE_SUCCESS,
	UPDATE_CART_SUCCESS,
	DELETE_CART_SUCCESS,
} from '../actions/productActions';

const carts = (state = {}, action) => {
	const carts = action.carts;
	switch (action.type) {
		case ADD_TO_CART_SUCCESS:
			return {
				...state,
				cartAdd: action.cartAdd,
			};
		case UPDATE_CART_SUCCESS:
			return {
				...state,
				cartUpdate: action.cartUpdate,
			};
		case DELETE_CART_SUCCESS:
			return {
				...state,
				cartDelete: action.cartDelete,
			};
		case CHECKOUT_SUCCESS:
			return {
				...state,
				quoteId: null,
				carts: [],
				checkoutSuccess: action.success,
			};
		case CREATE_QUOTE_SUCCESS:
			return {
				...state,
				carts: [],
				quoteId: action.quoteId,
			};
		case GET_CART_SUCCESS:
			return {
				...state,
				carts,
			};
		case ADD_TO_CART_FAIL:
			return {
				...state,
			};

		default:
			return state;
	}
};

export default carts;
