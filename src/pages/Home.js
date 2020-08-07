import React from 'react';
import { connect } from 'react-redux';
import './home.css';
import { requestGetProduct } from '../actions/productActions';
import InfoStaff from '../components/InfoStaff';
import Search from '../components/Search';
import ProductList from '../components/ProductList';
import Cart from '../components/Cart';

class Home extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="container-fluid h-100 border">
				<div className="row h-15 p-4">
					<InfoStaff />
					<Search logout={this.props.logout} />
				</div>
				<div className="row h-85 p-2 border">
					<div className="col-3" style={{ height: window.innerHeight }}>
						<Cart />
					</div>
					<div className="col-9 h-100">
						<ProductList />
					</div>
				</div>
			</div>
		);
	}
}

const mapStateToProps = (state) => state;

const mapDispatchToProps = {
	requestGetProduct,
};

const HomeConnected = connect(null, null)(Home);
export default HomeConnected;
