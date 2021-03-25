import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TransactionService } from '../services/transactionService/transaction.service';
import { UserService } from '../services/userService/user.service';

@Component({
  selector: 'app-commissions',
  templateUrl: './commissions.component.html',
  styleUrls: ['./commissions.component.scss'],
})
export class CommissionsComponent implements OnInit {

  commissions : any;
  compteId : number;
  username : number;
  users = [];


  constructor(private userService : UserService, private transactionService : TransactionService, private router : Router) { }

  ngOnInit() {
    this.getUser();
  }

  getUser(){
    this.userService.getUserByUsername().subscribe(
      res => {
        this.getCompteByUsername(res["telephone"])
      }
    );
  }

  getCompteByUsername(username){
    this.userService.getCompteByUserUsername(username).subscribe(
      (data : any) => {
        this.compteId = data["id"],
        this.getCommissionByCompteId(this.compteId),
        this.getUsersOfCompteById(this.compteId)
      }
    );
  }

  getCommissionByCompteId(id){
    return this.transactionService.getCommissionByCompte(id).subscribe({
      next: res=>{
        this.commissions = res,
        console.log(this.commissions[0]["data"])
      }
    });
  }

  getUsersOfCompteById(id){
    return this.userService.getUsersByCompteId(id).subscribe(
      (res:any) => {
        this.users = res["agences"]["users"],
        console.log(this.users)
      }
    )
  }

  getBackHome(){
    return this.router.navigate(['/acceuil']);
  }
}
