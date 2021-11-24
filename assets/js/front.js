// Charge le fichier scss du front
require('../scss/front.scss');
require('../../node_modules/tinymce/tinymce');
require('../../node_modules/tinymce/themes/silver/index');
require('../../node_modules/tinymce/icons/default/index');

import '@popperjs/core';
import 'bootstrap';

// Init wysiwyg
tinymce.init({
    selector: 'textarea.wysiwyg',
});

window.addEventListener('load', () => {

    let searchAddress = document.querySelector('#registration_form_address');

    if (null !== searchAddress) {

        let addrSelect = document.querySelector('#address_results');
        let url = addrSelect.getAttribute('data-url');

        searchAddress.addEventListener('change', () => {

            let xhttp = new XMLHttpRequest();
            xhttp.open('GET', url + "?search=" + searchAddress.value);

            xhttp.onload = () => {
                let results = JSON.parse(xhttp.responseText);
                addrSelect.innerHTML = ""; // reset select

                for (const address of results.features) {
                    let option = document.createElement('option');
                    option.innerHTML = option.value = address.properties.label;
                    addrSelect.appendChild(option);
                }
            };

            xhttp.send();
        });

        addrSelect.addEventListener('click', () => {
            searchAddress.value = addrSelect.value;
        });

    }

    for (const btn of document.querySelectorAll('.btn-like')) {
        btn.addEventListener('click', (event) => {
            event.preventDefault();

            let xhttp = new XMLHttpRequest;
            xhttp.open('GET', btn.getAttribute('href'));

            xhttp.onload = () => {
                let json = JSON.parse(xhttp.responseText);

                if (json.status === 'success') {
                    btn.classList.toggle('active', json.active);

                    btn.querySelector('span').innerHTML = (parseInt(btn.querySelector('span').innerHTML) + (json.active ? 1 : -1));
                }
            };

            xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");

            xhttp.send();
        });
    }
});