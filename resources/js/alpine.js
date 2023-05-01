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
alphine.data('activity', () => ({
	image_icon_url: '',
	image_banner_url: '',
	handleChangeImageIcon(e) {
		let file = e.target.files[0]
		if (file) 
		{
			this.image_icon_url = URL.createObjectURL(file)
		}
	},
	handleChangeImageBanner(e) {
		let file = e.target.files[0]
		if (file) 
		{
			this.image_banner_url = URL.createObjectURL(file)
		}
	}
}))
alphine.plugin(intersect)
window.Alpine = alphine
alphine.start()