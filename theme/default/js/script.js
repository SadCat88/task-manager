console.log('script.js is run');

//-- Функуия для пересчета высоты textarea
let setHeightInput = function () {

	let allInputText = document.querySelectorAll( '.form-item-input.--text' );
	if ( allInputText.length !== 0 ) {
		allInputText.forEach( ( element, index ) => {

			if ( element.scrollHeight > element.offsetHeight ) {

				let newHeight = element.scrollHeight + element.offsetHeight - element.clientHeight + "px";
				element.style.cssText = `height: ${newHeight};`;
			}

		} );
	}

}

//-- Обработчик нажатия Enter внутри формы
let allInputText = document.querySelectorAll( '.form-item-input.--text' );
if ( allInputText.length !== 0 ) {
	allInputText.forEach( ( element, index ) => {
		element.addEventListener( 'keydown', ( event ) => {

			//-- Пересчет высоты textarea
			setHeightInput();

			// if ( event.keyCode == 13 ) {
				// event.preventDefault();

				// document.querySelector( '.form' ).submit();
			// }
			
		} );
	} );
}

//-- Пересчет высоты textarea
setHeightInput();

//-- Изменение размера окна
window.addEventListener( 'resize', ( event ) => {
	//-- Пересчет высоты textarea
	setHeightInput();
} );