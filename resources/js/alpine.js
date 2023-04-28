import alphine from 'alpinejs'
import intersect from "@alpinejs/intersect";

alphine.data('avatar', () => ({
	url: '',
	handleChangeAvatar(e) {
		let file = e.target.files[0]
		if (file) this.url = URL.createObjectURL(file)
	}
}))
alphine.data('heroes', () => ({
	show_preview: false,
	image_url: '',
	handleChangeImage(e) {
		let file = e.target.files[0]
		if (file) 
		{
			this.image_url = URL.createObjectURL(file)
			this.show_preview = true
		}
	}
}))
alphine.plugin(intersect)
window.Alpine = alphine
alphine.start()