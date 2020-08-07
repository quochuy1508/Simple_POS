// authentication
export const REQUEST_GET_PRODUCT = 'REQUEST_GET_PRODUCT';
export const PROCESS_GET_PRODUCT = 'PROCESS_GET_PRODUCT';
export const GET_PRODUCT_SUCCESS = `GET_PRODUCT_SUCCESS`;
export const GET_PRODUCT_FAIL = `GET_PRODUCT_FAIL`;

export const REQUEST_ADD_TO_CART = 'REQUEST_ADD_TO_CART';
export const PROCESS_ADD_TO_CART = 'PROCESS_ADD_TO_CART';
export const ADD_TO_CART_SUCCESS = `ADD_TO_CART_SUCCESS`;
export const ADD_TO_CART_FAIL = `ADD_TO_CART_FAIL`;

export const REQUEST_UPDATE_CART = 'REQUEST_UPDATE_CART';
export const PROCESS_UPDATE_CART = 'PROCESS_UPDATE_CART';
export const UPDATE_CART_SUCCESS = `UPDATE_CART_SUCCESS`;
export const UPDATE_CART_FAIL = `UPDATE_CART_FAIL`;

export const REQUEST_DELETE_CART = 'REQUEST_DELETE_CART';
export const PROCESS_DELETE_CART = 'PROCESS_DELETE_CART';
export const DELETE_CART_SUCCESS = `DELETE_CART_SUCCESS`;
export const DELETE_CART_FAIL = `DELETE_CART_FAIL`;

export const REQUEST_GET_CART = 'REQUEST_GET_CART';
export const PROCESS_GET_CART = 'PROCESS_GET_CART';
export const GET_CART_SUCCESS = `GET_CART_SUCCESS`;
export const GET_CART_FAIL = `GET_CART_FAIL`;

export const REQUEST_CREATE_QUOTE = 'REQUEST_CREATE_QUOTE';
export const PROCESS_CREATE_QUOTE = 'PROCESS_CREATE_QUOTE';
export const CREATE_QUOTE_SUCCESS = `CREATE_QUOTE_SUCCESS`;
export const CREATE_QUOTE_FAIL = `CREATE_QUOTE_FAIL`;

export const REQUEST_CHECKOUT = 'REQUEST_CHECKOUT';
export const PROCESS_CHECKOUT = 'PROCESS_CHECKOUT';
export const CHECKOUT_SUCCESS = `CHECKOUT_SUCCESS`;
export const CHECKOUT_FAIL = `CHECKOUT_FAIL`;
export const requestGetProduct = (params) => ({
	type: REQUEST_GET_PRODUCT,
	payload: params,
});

export const processGetProduct = (type, products) => {
	return {
		type,
		products,
	};
};

export const requestAddToCart = (params) => ({
	type: REQUEST_ADD_TO_CART,
	payload: params,
});

export const processAddToCart = (type, cartAdd) => {
	return {
		type,
		cartAdd,
	};
};

export const requestUpdateCart = (params) => ({
	type: REQUEST_UPDATE_CART,
	payload: params,
});

export const processUpdateCart = (type, cartUpdate) => {
	return {
		type,
		cartUpdate,
	};
};
export const requestDeleteCart = (params) => ({
	type: REQUEST_DELETE_CART,
	payload: params,
});

export const processDeleteCart = (type, cartDelete) => {
	return {
		type,
		cartDelete,
	};
};

export const requestGetCart = (params) => ({
	type: REQUEST_GET_CART,
	payload: params,
});

export const processGetCart = (type, carts) => {
	return {
		type,
		carts,
	};
};

export const requestCreateQuote = () => ({
	type: REQUEST_CREATE_QUOTE,
});

export const processCreateQuote = (type, quoteId) => {
	return {
		type,
		quoteId,
	};
};
export const requestCheckout = () => ({
	type: REQUEST_CHECKOUT,
});

export const processCheckout = (type, success) => {
	return {
		type,
		success,
	};
};
