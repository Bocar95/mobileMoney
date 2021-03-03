import { Component, OnInit } from '@angular/core';
import { CompteService } from '../services/compteService/compte.service';

@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrls: ['./acceuil.component.scss'],
})
export class AcceuilComponent implements OnInit {

  constructor(private compteService : CompteService) { }

  ngOnInit() {
    console.log(this.agenceId());
  }

  userRole () {
    let token = localStorage.getItem('token');
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    var element = JSON.parse(jsonPayload);
    
    return element["roles"];
  }

  agenceId () {
    let token = localStorage.getItem('token');
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    var element = JSON.parse(jsonPayload);
    
    return element;
  }

  Admin() {
    if (this.userRole() == "ROLE_ADMIN_AGENCE" || this.userRole() == "ROLE_ADMIN_SYSTEME") {
      return true;
    } 
  }

}
