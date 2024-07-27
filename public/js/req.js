const req = {
	async request(method, endpoint, obj, isFile = false, isLoader = true) {
		try {

			const loaderStore = useLoaderStore()

			if (isLoader) {
				loaderStore.increment()
			}

			let headers = {
				'Accept': 'application/json',
				'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			}

			if (method == 'GET') {

				var response = await fetch(endpoint + '?' + this.serialize(obj), {
					method: method,
					headers: headers,
				})

			} else if (isFile) {

				// headers['Content-Type'] = 'multipart/form-data'

				var response = await fetch(endpoint, {
					method: method,
					headers: headers,
					body: this.formdata(obj)
				})

			} else {

				// headers['Content-Type'] = 'application/x-www-form-urlencoded'
				headers['Content-Type'] = 'application/json'

				var response = await fetch(endpoint, {
					method: method,
					headers: headers,
					body: JSON.stringify(obj),
					// body: this.serialize(obj)
				})
			}
			
			let json = []
			let success = true

			try {
				json = await response.json()
			} catch (error) {
				success = false
			}

			// TODO: add HTTP response code

			if (isLoader) {
				loaderStore.decrement()
			}

			return {
				success: success && response.status === 200,
				status: response.status,
				data: json,
			}

		} catch (error) {

			console.error(error)
		}

		return {success: false, status: 0, data: {}}
	},
	async post(endpoint, obj, isFile = false, isLoader = true) {

		return await this.request("POST", endpoint, obj, isFile, isLoader)
	},
	async get(endpoint, obj, isFile = false, isLoader = true) {

		return await this.request("GET", endpoint, obj, isFile, isLoader)
	},
	async put(endpoint, obj, isFile = false, isLoader = true) {

		return await this.request("PUT", endpoint, obj, isFile, isLoader)
	},
	async delete(endpoint, obj, isFile = false, isLoader = true) {

		return await this.request("DELETE", endpoint, obj, isFile, isLoader)
	},
	serialize(obj, prefix) {
		let str = [], p;
		for (p in obj) {
			if (obj.hasOwnProperty(p)) {
			let k = prefix ? prefix + "[" + p + "]" : p,
				v = obj[p];
				str.push((v !== null && typeof v === "object") ?
				serialize(v, k) :
				encodeURIComponent(k) + "=" + encodeURIComponent(v));
			}
		}
		return str.join("&");
	},
	formdata(obj) {

		let formData = new FormData()

		for (const i in obj) {

			formData.append(i, obj[i])
		}

		return formData
	},
}