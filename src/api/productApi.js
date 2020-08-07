import { stringify } from 'qs';
import request from '../utils/request';
// import CONFIG from '@/utils/config';
// import log from '@/utils/log';

// user
export async function queryCourses(params) {
	return request(`http://localhost:6868/api/courses/?${stringify(params)}`);
}

export function detailCourses(id) {
	// const urlRequest = `${API_ENDPOINT}/companies/${id}`;
	return request(`http://localhost:6868/api/courses/${id}`, {
		method: 'GET',
	});
}

export async function removeCourses(id) {
	'id', id;
	return request(`http://localhost:6868/api/courses/${id}`, {
		method: 'DELETE',
	});
}

export async function addCourses(params) {
	return request(`http://localhost:6868/api/courses`, {
		method: 'POST',
		body: {
			...params,
			method: 'post',
		},
	});
}

export async function updateCourses(id, params) {
	// const urlRequest = `${API_ENDPOINT}/companies/${id}`;
	const urlRequest = `http://localhost:6868/api/courses/${id}`;
	return request(urlRequest, {
		method: 'PUT',
		body: {
			...params,
			method: 'update',
		},
	});
}

export async function queryCoursesAll(params) {
	const { filter, sort, range } = params;
	const query = {
		filter: JSON.stringify(filter),
		sort: JSON.stringify(sort || ['id', 'DESC']),
		range: range ? JSON.stringify(range) : null,
	};
	return request(`http://localhost:6868/api/courses?${stringify(query)}`);
	// return request(`http://localhost:6868/Courses/get/all`);
}

export async function buyCourses(params) {
	return request(`http://localhost:6868/api/userCourse`, {
		method: 'POST',
		body: {
			...params,
			method: 'post',
		},
	});
}

export async function queryUserCourseAll(params) {
	const { filter, sort, range } = params;
	const query = {
		filter: JSON.stringify(filter),
		sort: JSON.stringify(sort || ['id', 'DESC']),
		range: range ? JSON.stringify(range) : null,
	};
	return request(`http://localhost:6868/api/userCourse?${stringify(query)}`);
	// return request(`http://localhost:6868/Courses/get/all`);
}

export async function updateUserCourse(id, params) {
	// const urlRequest = `${API_ENDPOINT}/companies/${id}`;
	const urlRequest = `http://localhost:6868/api/userCourse/${id}`;
	return request(urlRequest, {
		method: 'PUT',
		body: {
			...params,
			method: 'update',
		},
	});
}

export async function updateUserCourseByUserId(params) {
	// const urlRequest = `${API_ENDPOINT}/companies/${id}`;
	const urlRequest = `http://localhost:6868/api/userCourse/update/userId`;
	return request(urlRequest, {
		method: 'PUT',
		body: {
			...params,
			method: 'update',
		},
	});
}
