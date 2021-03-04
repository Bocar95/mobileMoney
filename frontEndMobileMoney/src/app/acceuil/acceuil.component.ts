import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../services/authService/auth.service';
import { CompteService } from '../services/compteService/compte.service';
import { UserService } from '../services/userService/user.service';

@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrls: ['./acceuil.component.scss'],
})
export class AcceuilComponent implements OnInit {

  compte = [];

  constructor(private userService: UserService, private router: Router) { }

  ngOnInit() {
    this.userService.getCompteByUserUsername(this.userUsername()).subscribe(
      (compteElements : any) => {
        this.compte= compteElements,
        console.log(this.compte)
      }
    );
  }

  tokenElement() {
    let token = localStorage.getItem('token');
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    var element = JSON.parse(jsonPayload);
    return element;
  }

  userRole () {
    let role = this.tokenElement();
    return role["roles"];
  }

  userUsername() {
    let username = this.tokenElement();
    return username["username"];
  }

  Admin() {
    if (this.userRole() == "ROLE_ADMIN_AGENCE" || this.userRole() == "ROLE_ADMIN_SYSTEME") {
      return true;
    } 
  }

}
