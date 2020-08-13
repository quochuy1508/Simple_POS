import { stringify } from 'qs';
import request from '../utils/request';

/**
 * Method queryCourses
 *
 * @param {object} params
 */
export async function queryCourses(params) {
	return request(`http://localhost:6868/api/courses/?${stringify(params)}`);
}

/**
 *
 * @param {int|string} id
 */
export function detailCourses(id) {
	// const urlRequest = `${API_ENDPOINT}/companies/${id}`;
	return request(`http://localhost:6868/api/courses/${id}`, {
		method: 'GET',
	});
}

/**
 *
 * @param {int|string} id
 */
export async function removeCourses(id) {
	'id', id;
	return request(`http://localhost:6868/api/courses/${id}`, {
		method: 'DELETE',
	});
}

/**
 *
 * @param {object} params
 */
export async function addCourses(params) {
	return request(`http://localhost:6868/api/courses`, {
		method: 'POST',
		body: {
			...params,
			method: 'post',
		},
	});
}
/**
 *
 * @param {int|string} id
 * @param {object} params
 */
export async function updateCourses(id, params) {
	const urlRequest = `http://localhost:6868/api/courses/${id}`;

	return request(urlRequest, {
		method: 'PUT',
		body: {
			...params,
			method: 'update',
		},
	});
}

/**
 *
 * @param {object} params
 */
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

/**
 *
 * @param {object} params
 */
export async function buyCourses(params) {
	return request(`http://localhost:6868/api/userCourse`, {
		method: 'POST',
		body: {
			...params,
			method: 'post',
		},
	});
}

/**
 *
 * @param {object} params
 */
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

/**
 *
 * @param {int|string} id
 * @param {object} params
 */
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

/**
 *
 * @param {object} params
 */
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
