import { createStore, compose, applyMiddleware } from 'redux';
import { createEpicMiddleware, combineEpics } from 'redux-observable';
import rootReducer from './reducers';
import loginEpic from './epics/loginEpic';
import productEpic from './epics/productEpic';
import addToCartEpic from './epics/addToCartEpic';
import getCartEpic from './epics/getCartEpic';
import quoteIdEpic from './epics/quoteIdEpic';
import checkoutEpic from './epics/checkoutEpic';
import updateCartEpic from './epics/updateCartEpic';
import deleteCartEpic from './epics/deleteCartEpic';

// set up our composeEnhancers function, baed on the existence of the
// DevTools extension when creating the store
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const epicMiddleware = createEpicMiddleware();

const initialState = {
	// choices: ['Madrid', 'Havana', 'New York'],
	// loading: false,
	// error: undefined,
	// city: '',
	// data: {},
};

const store = createStore(rootReducer, initialState, composeEnhancers(applyMiddleware(epicMiddleware)));

const rootEpics = combineEpics(
	loginEpic,
	productEpic,
	addToCartEpic,
	getCartEpic,
	quoteIdEpic,
	checkoutEpic,
	updateCartEpic,
	deleteCartEpic
);

// order matters
epicMiddleware.run(rootEpics);

export default store;
