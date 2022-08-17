import {Controller} from '@hotwired/stimulus';

export default class extends Controller {

  static targets = ['button']

  connect() {
    console.log('connecting to this controller');
  }

  toggle() {
    document.querySelector('#searchBox > .message-body').classList.toggle('is-hidden');
  }
}
