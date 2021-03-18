import { Location } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Storage } from '@ionic/storage';
import { Subject } from 'rxjs';
import { UserService } from '../services/userService/user.service';

@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrls: ['./acceuil.component.scss'],
})
export class AcceuilComponent implements OnInit {

  compte = [];

  private  _refreshNeeded$ = new Subject<void>();

  constructor(private userService: UserService, private router: Router, private location : Location, private storage : Storage) { }

  ngOnInit() {
    this.userService.getCompteByUserUsername(this.userUsername()).subscribe(
      (compteElements : any) => {
        this.compte = compteElements,
        console.log(this.compte)
      }
    );
    this.reloadComponent();
  }

  refresh(): void {
    this.router.navigateByUrl("/refresh", { skipLocationChange: true }).then(() => {
      console.log(decodeURI(this.location.path()));
      this.router.navigate([decodeURI(this.location.path())]);
    });
  }

  refreshNeeded$() {
    return this._refreshNeeded$ ;
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.refresh();
    return this.router.navigate(['/acceuil']);
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

  userUsername() {
    let username = this.tokenElement();
    return username["username"];
  }

  getCompte(){
    return this.userService.getCompteByUserUsername(this.userUsername()).subscribe(
      (compteElements : any) => {
        this.compte = compteElements,
        console.log(this.compte)
      }
    ), this.reloadComponent();
  }

  userRole () {
    let role = this.tokenElement();
    return role["roles"];
  }

  Admin() {
    if (this.userRole() == "ROLE_ADMIN_AGENCE" || this.userRole() == "ROLE_ADMIN_SYSTEME") {
      return true;
    } 
  }

}
