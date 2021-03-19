import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TransactionService } from '../services/transactionService/transaction.service';
import { UserService } from '../services/userService/user.service';

@Component({
  selector: 'app-compte-transactions',
  templateUrl: './compte-transactions.component.html',
  styleUrls: ['./compte-transactions.component.scss'],
})
export class CompteTransactionsComponent implements OnInit {

  allTrans : any;
  compteId : number;
  username:number;

  constructor(private userService : UserService, private transactionService : TransactionService, private router : Router) { }

  ngOnInit() {
    this.getCompteId();
  }

  getCompteId(){
    this.tokenElement();
    return this.userService.getCompteByUserUsername(this.username).subscribe(
      (data : any) => {
        this.compteId = data["id"],
        this.getTransByCompteId(this.compteId)
      }
    );
  }

  getTransByCompteId(id){
    return this.transactionService.getTransactionsByCompte(id).subscribe({
      next: res=>{
        this.allTrans = res,
        console.log(this.allTrans[0]["data"]);
      }
    });
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

}
