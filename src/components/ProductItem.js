import React, { useState } from 'react';
import { connect } from 'react-redux';
import { requestAddToCart } from '../actions/productActions';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCartPlus } from '@fortawesome/free-solid-svg-icons';
import PropTypes from 'prop-types';

const ProductItem = ({ product, requestAddToCart }) => {
	const [dis, setDis] = useState(false);
	const [chooseCart, setChooseCart] = useState(null);
	return (
		<div className="col-sm-3 rounded border">
			<div className="row justify-content-center p-2" style={{ width: '100%' }}>
				<div className="col-sm-5">
					<div>
						<span className="text-black-50 text-wrap">{product.name}</span>
					</div>
					<div>
						<span className="badge badge-secondary">SKU: {product.sku}</span>
						<span className="badge badge-info ">Price: {product.price}$ </span>
						<br />
						{product.type_id === 'simple' ? (
							<button type="button" className="btn btn-warning" onClick={() => requestAddToCart(product)}>
								<FontAwesomeIcon icon={faCartPlus} />
							</button>
						) : (
							<>
								<button
									type="button"
									className="btn btn-warning"
									data-toggle="modal"
									data-target={`#modalCart${product.id}`}
								>
									<FontAwesomeIcon icon={faCartPlus} />
								</button>

								<div
									className="modal fade"
									id={`modalCart${product.id}`}
									tabIndex="-1"
									data-backdrop="false"
									role="dialog"
									aria-labelledby="exampleModalLabel"
									aria-hidden="false"
								>
									<div className="modal-dialog modal-lg" role="document">
										<div className="modal-content w-100">
											<div className="modal-header">
												<h4 className="modal-title" id="myModalLabel">
													List Product Configure
												</h4>
												<button
													type="button"
													className="close"
													data-dismiss="modal"
													aria-label="Close"
												>
													<span aria-hidden="true">×</span>
												</button>
											</div>
											<div className="modal-body">
												<div className="scrollit">
													<table className="table table-hover text-center">
														<thead>
															<tr>
																<th>Sku</th>
																<th>Name</th>
																<th>Size</th>
																<th>Color</th>
																<th>Choose</th>
																<th>
																	<button type="button" onClick={() => setDis(false)}>
																		&times;
																	</button>
																</th>
															</tr>
														</thead>
														<tbody>
															{product.childItems.map((e) => (
																<tr key={e.entity_id}>
																	<th scope="row">{e.sku}</th>
																	<td>{e.name}</td>
																	<td>{e.size.label}</td>
																	<td>{e.color.label}</td>
																	<td>
																		<input
																			onClick={() => {
																				setDis(true);
																				setChooseCart({
																					sku: product.sku,
																					product_option: {
																						extension_attributes: {
																							configurable_item_options: [
																								{
																									option_id:
																										e.size
																											.option_id,
																									option_value: parseInt(
																										e.size
																											.option_value
																									),
																								},
																								{
																									option_id:
																										e.color
																											.option_id,
																									option_value: parseInt(
																										e.color
																											.option_value
																									),
																								},
																							],
																						},
																					},
																					extension_attributes: {},
																				});
																			}}
																			type="checkbox"
																			disabled={dis}
																			style={{
																				width: '26px',
																				height: '26px',
																			}}
																		/>
																	</td>
																</tr>
															))}
														</tbody>
													</table>
												</div>
											</div>
											<div className="modal-footer">
												<button
													type="button"
													className="btn btn-outline-primary"
													data-dismiss="modal"
												>
													Close
												</button>
												<button
													className="btn btn-primary"
													onClick={() =>
														chooseCart
															? requestAddToCart(chooseCart) && setDis(false)
															: null
													}
												>
													Add To Cart
												</button>
											</div>
										</div>
									</div>
								</div>
							</>
						)}
					</div>
				</div>
				<div className="col-sm-7 d-flex align-items-end">
					<img
						src={product.image}
						className="img-fluid ml-4"
						alt={product.image}
						width="110px !important"
						height="100% !important"
						// style={{ width: '100%', height: '100%', objectFit: 'cover' }}
					/>
				</div>
			</div>
		</div>
	);
};

// const mapStateToProps = ({ products }) => products;

ProductItem.propTypes = {
	product: PropTypes.object,
	requestAddToCart: PropTypes.func,
};
const mapDispatchToProps = {
	requestAddToCart,
};

const ProductItemConnected = connect(null, mapDispatchToProps)(ProductItem);

export default ProductItemConnected;
