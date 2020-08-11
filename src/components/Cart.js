import React, { useEffect } from 'react';
import { connect } from 'react-redux';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';
import PropTypes from 'prop-types';
import {
	requestGetCart,
	requestCreateQuote,
	requestCheckout,
	requestUpdateCart,
	requestDeleteCart,
} from '../actions/productActions';
import Cookie from 'js-cookie';

const Cart = ({ requestGetCart, carts, requestCreateQuote, requestCheckout, requestUpdateCart, requestDeleteCart }) => {
	const totalCart =
		(carts &&
			carts.carts &&
			carts.carts.reduce((total, currentValue) => {
				return (total += currentValue.qty * currentValue.price);
			}, 0)) ||
		0;

	useEffect(() => {
		if (!Cookie.get('quoteId')) {
			requestCreateQuote();
		} else {
			requestGetCart();
		}
	}, [carts.cartAdd, carts.cartUpdate, carts.cartDelete]);

	return (
		<div className="h-100">
			<p className="d-flex justify-content-center display-4">Cart</p>
			<div className="anyClass">
				<div className="row">
					<div className="col-sm-12 col-md-10 col-md-offset-1">
						<table className="table table-hover">
							<thead>
								<tr>
									<th>Product</th>
									<th>Quantity</th>
									<th className="text-center">Price</th>
									<th className="text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								{carts.carts &&
									Array.isArray(carts.carts) &&
									carts.carts.map((cart) => (
										<tr key={cart.item_id}>
											<td className="col-sm-8 col-md-4">
												<div className="media">
													<div className="media-body">
														<p>
															<strong>Name</strong>: {cart.name}
														</p>
														<p>
															<strong>Sku</strong>:{cart.sku}
														</p>
													</div>
												</div>
											</td>
											<td className="col-sm-1 col-md-1" style={{ textAlign: 'center' }}>
												<button
													className="w-100 no-border"
													onClick={() =>
														requestUpdateCart({
															id: cart.item_id,
															sku: cart.sku,
															qty: parseInt(cart.qty) + 1,
														})
													}
												>
													+
												</button>
												<input
													className="form-control"
													value={cart.qty}
													disabled
													style={{ textAlign: 'center' }}
												/>
												<button
													className="w-100"
													onClick={() =>
														requestUpdateCart({
															id: cart.item_id,
															sku: cart.sku,
															qty: parseInt(cart.qty) - 1,
														})
													}
												>
													-
												</button>
											</td>
											<td className="col-sm-1 col-md-1 text-center">
												<strong>{parseFloat(cart.price)}</strong>
											</td>
											<td className="col-sm-1 col-md-1 text-center">
												<strong>{cart.price * cart.qty}</strong>
											</td>
											<td className="col-sm-1 col-md-1">
												<FontAwesomeIcon
													icon={faTrash}
													// onClick={() => requestDeleteCart({ id: cart.item_id })}
													onClick={() =>
														(document.getElementById('id01').style.display = 'block')
													}
												/>
												<div id="id01" className="modal">
													<form className="modal-content text-center">
														<div className="container">
															<h1>Delete Product</h1>
															<p>Are you sure you want to delete your product?</p>

															<div className="clearfix d-flex justify-content-center">
																<button
																	type="button"
																	style={{ width: '20%' }}
																	onClick={() =>
																		(document.getElementById('id01').style.display =
																			'none')
																	}
																	className="cancelbtn"
																>
																	Cancel
																</button>
																<button
																	type="button"
																	style={{ width: '20%' }}
																	onClick={() => {
																		document.getElementById('id01').style.display =
																			'none';
																		requestDeleteCart({ id: cart.item_id });
																	}}
																	className="deletebtn"
																>
																	Delete
																</button>
															</div>
														</div>
													</form>
												</div>
											</td>
										</tr>
									))}
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div className="bg-light list-group-item d-flex justify-content-between">
				<span>Total (USD)</span>
				<strong>{totalCart}</strong>
			</div>
			<div className="d-flex justify-content-center mt-2">
				<button type="button" className="btn btn-success w-100" onClick={() => requestCheckout()}>
					Checkout
				</button>
			</div>
		</div>
	);
};
Cart.propTypes = {
	requestGetCart: PropTypes.func,
	carts: PropTypes.object,
	requestCreateQuote: PropTypes.func,
	requestCheckout: PropTypes.func,
	requestUpdateCart: PropTypes.func,
	requestDeleteCart: PropTypes.func,
};

const mapStateToProps = (state) => state;

const mapDispatchToProps = {
	requestGetCart,
	requestCreateQuote,
	requestCheckout,
	requestUpdateCart,
	requestDeleteCart,
};

const CartConnected = connect(mapStateToProps, mapDispatchToProps)(Cart);

export default CartConnected;
