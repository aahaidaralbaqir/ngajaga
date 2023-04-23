import alphine from 'alpinejs'
import intersect from "@alpinejs/intersect";

alphine.data('avatar', () => ({
	url: '',
	handleChangeAvatar(e) {
		let file = e.target.files[0]
		if (file) this.url = URL.createObjectURL(file)
	}
}))
alphine.plugin(intersect)
window.Alpine = alphine
alphine.start()