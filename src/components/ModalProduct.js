import React from 'react';
import PropTypes from 'prop-types';

const ModalProduct = ({ e }) => {
	return (
		<tr key={e.entity_id}>
			<th scope="row">{e.sku}</th>
			<td>{e.name}</td>
			<td>{e.size.label}</td>
			<td>{e.color.label}</td>
			<td>
				<input
					// onClick={() =>
					// 	setChooseCart({
					// 		sku: product.sku,
					// 		product_option: {
					// 			extension_attributes: {
					// 				configurable_item_options: [
					// 					{
					// 						option_id: e.size.option_id,
					// 						option_value: parseInt(e.size.option_value),
					// 					},
					// 					{
					// 						option_id: e.color.option_id,
					// 						option_value: parseInt(e.color.option_value),
					// 					},
					// 				],
					// 			},
					// 		},
					// 		extension_attributes: {},
					// 	})
					// }
					type="checkbox"
					style={{
						width: '26px',
						height: '26px',
					}}
				/>
			</td>
		</tr>
	);
};

ModalProduct.propTypes = {
	e: PropTypes.object,
};
export default ModalProduct;
