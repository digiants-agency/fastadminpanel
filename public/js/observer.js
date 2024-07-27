class Observer {

	static events = []

	static dispatch(title, ...args) {

		for (let e of this.events) {
			if (e.title == title) {
				e.func(...args)
			}
		}
	}

	static add(title, func) {

		this.events.push({title: title, func: func})
	}

	static remove(title, func) {

		this.events = this.events.filter((event)=>{
			return !(event.title == title && event.func == func)
		})
	}
}