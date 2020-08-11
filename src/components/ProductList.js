import React, { useEffect, useState } from 'react';
import { connect } from 'react-redux';
import { requestGetProduct } from '../actions/productActions';
import ProductItem from './ProductItem';
import ReactPaginate from 'react-paginate';
import './pagination.css';
const ProductList = ({ requestGetProduct, products }) => {
	const [currentPage, setCurrentPage] = useState(0);
	const [pageCount, setPageCount] = useState(1);

	useEffect(() => {
		requestGetProduct({ currentPage });
	}, [currentPage]);

	useEffect(() => {
		if (products && products.total_count) {
			const pageCountTemp = Math.ceil(products.total_count / 16);
			setPageCount(pageCountTemp);
		}
	}, [products]);

	return (
		<>
			<div className="container-fluid h-90 p-2 ">
				<div className="row">
					{products &&
						products.items &&
						products.items.map((product) => <ProductItem key={product.id} product={product} />)}
				</div>
			</div>
			<div className="h-10 d-flex justify-content-center">
				<ReactPaginate
					previousLabel={'prev'}
					nextLabel={'next'}
					breakLabel={'...'}
					breakClassName={'break-me'}
					pageCount={pageCount}
					marginPagesDisplayed={2}
					pageRangeDisplayed={5}
					onPageChange={(e) => setCurrentPage(e.selected + 1)}
					containerClassName={'pagination'}
					subContainerClassName={'pages pagination'}
					activeClassName={'active'}
				/>
			</div>
		</>
	);
};

const mapStateToProps = ({ products }) => products;

const mapDispatchToProps = {
	requestGetProduct,
};

const ProductListConnected = connect(mapStateToProps, mapDispatchToProps)(ProductList);

export default ProductListConnected;
