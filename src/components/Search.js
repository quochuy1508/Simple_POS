import React, { Component } from 'react';
import { requestGetProduct } from '../actions/productActions';
import { connect } from 'react-redux';

class Search extends Component {
	constructor(props) {
		super(props);
		this.state = { type: 'name', name: '' };

		this.handleChange = this.handleChange.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
	}

	handleSubmit(event) {
		this.props.requestGetProduct({ type: this.state.type, value: this.state.name });
		event.preventDefault();
	}

	handleChange(event) {
		const target = event.target;
		const name = target.name;
		const value = target.value;
		console.log(name, value);
		this.setState({
			[name]: value,
		});
	}

	render() {
		return (
			<div className="col-9">
				<div className="row">
					<div className="input-group w-75 col-sm-9 d-flex justify-content-start">
						<form className="w-100" onSubmit={this.handleSubmit}>
							<div className="form-row align-items-center">
								<div className="col-2">
									<select
										name="type"
										className="custom-select w-80"
										id="inlineFormCustomSelect"
										onChange={this.handleChange}
									>
										<option value="name" defaultValue>
											By Name
										</option>
										<option value="sku">By SKU</option>
									</select>
								</div>
								<div className="col-8">
									<input
										type="text"
										name="name"
										className="form-control"
										id="inlineFormInput"
										placeholder="Please type name or sku of product"
										onChange={this.handleChange}
									/>
								</div>

								<div className="col-2">
									<button type="submit" className="btn btn-primary">
										Search
									</button>
								</div>
							</div>
						</form>
					</div>

					<div className="input-group-append col-sm-3 d-flex justify-content-end">
						<button type="button" className="btn btn-warning" onClick={() => this.props.logout()}>
							Logout
						</button>
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

const SearchConnected = connect(null, mapDispatchToProps)(Search);

export default SearchConnected;
