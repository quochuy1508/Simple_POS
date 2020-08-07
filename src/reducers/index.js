import { combineReducers } from 'redux';
import loginReducers from './loginReducers';
import productReducers from './productReducers';
import cartReducers from './cartReducers';

const rootReducer = combineReducers({
	users: loginReducers,
	products: productReducers,
	carts: cartReducers,
});
export default rootReducer;
