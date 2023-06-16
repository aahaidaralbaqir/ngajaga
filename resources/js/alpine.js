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
	recurring: false,
	showOnLandingPage: false,
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
	},
	changeRecurring(e) 
	{
		let checkBox = document.querySelector('input[name="recurring"]')
		checkBox.removeAttribute('checked')
		if (!this.recurring) checkBox.setAttribute('checked', true)
		this.recurring = !this.recurring
	},
	changeShowOnLandingPage(e)
	{
		let checkBox = document.querySelector('input[name="show_landing_page"]')
		checkBox.removeAttribute('checked')
		if (!this.showOnLandingPage) checkBox.setAttribute('checked', true)
		this.showOnLandingPage = !this.showOnLandingPage	
	}
}))
alphine.plugin(intersect)
window.Alpine = alphine
alphine.start()