import {Controller} from '@hotwired/stimulus';

export default class extends Controller {

  toggle() {
    document.querySelector('#searchBox > .message-body').classList.toggle('is-hidden');
  }

  clear() {
    this.element.querySelector('form').reset();
    Turbo.visit('/');

  }

}
