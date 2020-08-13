import React, { Component } from 'react';
import { connect } from 'react-redux';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import HomeConnected from './pages/Home';
import LoginConnected from './pages/Login';
import Cookies from 'js-cookie';
import './App.css';
import PropTypes from 'prop-types';

class App extends Component {
	constructor(props) {
		super(props);
		this.state = { auth: false, width: window.innerWidth, height: window.innerHeight };
		this.getCookieUser = this.getCookieUser.bind(this);
		this.logout = this.logout.bind(this);
	}

	UNSAFE_componentWillReceiveProps(nextProps) {
		const session = nextProps.session && nextProps.session[0] && nextProps.session[0];
		if (session.status) {
			this.setState({
				auth: true,
			});
			toast.success('Login Success!', {
				position: toast.POSITION.TOP_CENTER,
			});
			Cookies.set('users', 'logined');
			Cookies.set('nameStaff', session.name);

			this.setState({ redirect: true });
		} else {
			this.setState({
				auth: false,
			});
			toast.error(session.message, {
				position: toast.POSITION.TOP_CENTER,
			});
		}
	}

	getCookieUser() {
		const user = Cookies.get('users');
		if (user && user === 'logined') {
			this.setState({
				auth: true,
			});
		} else {
			this.setState({
				auth: false,
			});
		}
	}

	logout() {
		Cookies.remove('users');
		Cookies.remove('nameStaff');
		this.setState({
			auth: false,
		});
	}
	componentDidMount() {
		this.getCookieUser();
	}

	render() {
		// console.log('APP state: ', this.props);
		return (
			<div style={{ width: this.state.width, height: this.state.height }}>
				{this.state.auth ? <HomeConnected logout={this.logout} /> : <LoginConnected />}
				<ToastContainer />
			</div>
		);
	}
}
App.propTypes = {
	session: PropTypes.object,
};
const mapStateToProps = ({ users }) => users;

const mapDispatchToProps = {};
const AppContainer = connect(mapStateToProps, mapDispatchToProps)(App);

App.displayName = 'App';
export default AppContainer;
