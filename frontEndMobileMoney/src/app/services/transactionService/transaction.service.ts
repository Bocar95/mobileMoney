import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TransactionService {

  private transactionsUrl = "http://127.0.0.1:8000/api/user/transactions";
  private fraisCalculatorUrl = "http://127.0.0.1:8000/api/user/frais";
  private transactionByCodeUrl = "http://127.0.0.1:8000/api/user/transaction";
  private retraitUrl = "http://127.0.0.1:8000/api/user/transactions/retrait";

  constructor(private http : HttpClient) { }

  addDepot(data){
    return this.http.post<any>(this.transactionsUrl, data);
  }

  getFrais(montant:number){
    return this.http.get(`${this.fraisCalculatorUrl}/${montant}`);
  }

  getTransactionByCode(code){
    return this.http.get(`${this.transactionByCodeUrl}/${code}`)
  }

  retrait(data){
    return this.http.put(this.retraitUrl, data);
  }
}
