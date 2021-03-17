import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TransactionService } from '../services/transactionService/transaction.service';
import { UserService } from '../services/userService/user.service';

@Component({
  selector: 'app-list-transactions',
  templateUrl: './list-transactions.component.html',
  styleUrls: ['./list-transactions.component.scss'],
})
export class ListTransactionsComponent implements OnInit {

  tab = [];

  username : number;
  trans = [];
  userDepot;
  userRetrait;
  prenom;
  nom;

  constructor(private router : Router, private transationService : TransactionService, private userService : UserService) { }

  ngOnInit() {
    this.tokenElement();
    this.getUser();
  }

  getBackHome(){
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
    this.username = element["username"];
    return element;
  }

  getUser(){
    return this.transationService.getUserByUsername(this.username).subscribe(
      res => {
        console.log(res),
        this.getMyTransactions(res["id"])
      }
    );
  }

  getMyTransactions(id){
    return this.transationService.getTransactionOfUser(id).subscribe(
       res => {
        console.log(res),
        this.trans = [res],
        this.userDepot = res[0]["usersDepot"],
        this.userRetrait = res[0]["usersRetrait"],
        console.log(this.userDepot)
       }
     )
  }
  
}
