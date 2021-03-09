import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TransactionService {

  private transactionsUrl = "http://127.0.0.1:8000/api/user/transactions";
  private fraisCalculatorUrl = "http://127.0.0.1:8000/api/user/frais"

  constructor(private http : HttpClient) { }

  addDepot(data){
    return this.http.post<any>(this.transactionsUrl, data);
  }

  getFrais(montant:number){
    return this.http.get(`${this.fraisCalculatorUrl}/${montant}`);
  }
}
