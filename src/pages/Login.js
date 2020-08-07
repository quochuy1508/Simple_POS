import React, { Component, useState } from 'react';
import { connect } from 'react-redux';
import { Formik } from 'formik';
import { requestAuthenticateUser } from '../actions/loginActions';

class Login extends Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div
				className="container w-50 mh-100 my-auto justify-content-center align-self-center pt-4"
				style={{ backgroundColor: '#eee', height: '400px' }}
			>
				<h1>Login Form Staff!</h1>
				<Formik
					initialValues={{ username: '', password: '' }}
					validate={(values) => {
						const errors = {};
						if (!values.username) {
							errors.username = 'Required';
						} else if (!/^[A-Z0-9._%+-]{6,}$/i.test(values.username)) {
							errors.username = 'Invalid username';
						}
						return errors;
					}}
					onSubmit={(values, { setSubmitting }) => {
						// console.log('Hello');
						this.props.requestAuthenticateUser(values);
					}}
				>
					{({
						values,
						errors,
						touched,
						handleChange,
						handleBlur,
						handleSubmit,
						isSubmitting,
						/* and other goodies */
					}) => (
						<form onSubmit={handleSubmit}>
							<div className="form-group">
								<label htmlFor="username">Username: </label>
								<input
									type="text"
									name="username"
									onChange={handleChange}
									onBlur={handleBlur}
									value={values.username}
									className="form-control"
								/>
								{errors.username && touched.username && errors.username}
							</div>
							<div className="form-group">
								<label htmlFor="password">Password: </label>
								<input
									type="password"
									name="password"
									onChange={handleChange}
									onBlur={handleBlur}
									value={values.password}
									className="form-control"
								/>
								{errors.password && touched.password && errors.password}
							</div>

							<button type="submit" className="btn btn-primary">
								Login
							</button>
						</form>
					)}
				</Formik>
			</div>
		);
	}
}

const mapStateToProps = () => ({});

const mapDispatchToProps = {
	requestAuthenticateUser,
};

const LoginConnected = connect(mapStateToProps, mapDispatchToProps)(Login);
export default LoginConnected;
