import React from 'react';
import { connect } from 'react-redux';
import './home.css';
import InfoStaff from '../components/InfoStaff';
import Search from '../components/Search';
import ProductList from '../components/ProductList';
import Cart from '../components/Cart';
import PropTypes from 'prop-types';

class Home extends React.Component {
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

Home.propTypes = {
	logout: PropTypes.func,
};

// const mapStateToProps = (state) => state;

// const mapDispatchToProps = {
// 	requestGetProduct,
// };

const HomeConnected = connect(null, null)(Home);
export default HomeConnected;
