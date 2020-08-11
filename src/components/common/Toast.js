import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

function Toast({ type = 'success' }) {
	const position = toast.POSITION.TOP_CENTER;
	useEffect(() => {
		if (type === 'success') {
			toast.success('Success Notification !', {
				position,
			});
		}
	}, [type]);
	return (
		<div>
			<ToastContainer />
		</div>
	);
}

Toast.propTypes = {
	type: PropTypes.string,
};

export default Toast;
