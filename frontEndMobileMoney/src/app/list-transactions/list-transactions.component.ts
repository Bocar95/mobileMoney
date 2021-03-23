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

  tab2 : any;
  username : number;

  constructor(private router : Router, private transationService : TransactionService, private userService : UserService) { }

  ngOnInit() {
    this.getUser();
  }

  getUser(){
    this.userService.getUserByUsername().subscribe(
      res => {
        this.getTrans(res["id"])
      }
    );
  }

  getTrans(id){
    return this.transationService.fusion(id).subscribe({
      next: res=>{
        this.tab2 = res,
        console.log(this.tab2[0]["data"])
      }
    });
  }

  getBackHome(){
    return this.router.navigate(['/acceuil']);
  }
  
}
