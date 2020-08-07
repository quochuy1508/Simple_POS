import React from 'react';
import Cookies from 'js-cookie';

const InfoStaff = () => {
	return <div className="col-3">Staff: {Cookies.get('nameStaff')}</div>;
};

export default InfoStaff;
