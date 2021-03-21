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
  role : string; 

  constructor(private userService: UserService, private router: Router, private location : Location, private storage : Storage) { }

  ngOnInit() {
    this.userService.getUserByUsername().subscribe(
      res => {
        this.role = res["roles"],
        this.getCompte(res["telephone"]),
        this.Admin()
      }
    )
  }

  getCompte(username : number){
    return this.userService.getCompteByUserUsername(username).subscribe(
      (compteElements : any) => {
        this.compte = compteElements,
        console.log(this.compte)
      }
    )
  }

  Admin() {
    if (this.role == "ROLE_ADMIN_AGENCE" || this.role == "ROLE_ADMIN_SYSTEME") {
      return true;
    } 
  }

  // refresh(): void {
  //   this.router.navigateByUrl("/refresh", { skipLocationChange: true }).then(() => {
  //     console.log(decodeURI(this.location.path()));
  //     this.router.navigate([decodeURI(this.location.path())]);
  //   });
  // }

}
