import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

  toggle({params: {bggId}}) {
    let e = document.getElementById('details-' + bggId);
    e.style.display = e.style.display === 'none' ? 'table-row' : 'none';
  }
}
