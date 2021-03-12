import { Component, Input, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { ModalController } from '@ionic/angular';
import { TransactionService } from '../services/transactionService/transaction.service';

@Component({
  selector: 'app-retrait-modal',
  templateUrl: './retrait-modal.component.html',
  styleUrls: ['./retrait-modal.component.scss'],
})
export class RetraitModalComponent implements OnInit {

  @Input() data:any;

  confirmRetrait : FormGroup;

  constructor(private modalCtrl : ModalController, private formBuilder : FormBuilder, private transactionService : TransactionService, private router : Router) { }

  ngOnInit() {
    this.confirmRetrait = this.formBuilder.group({
      codeTrans : this.data[0]["codeTrans"],
      numCni : this.data[0]["numCni"],
      nomBeneficiaire : this.data[0]["nomBeneficiaire"],
      telephone : this.data[0]["telephone"],
      montant : this.data[0]["montant"],
      nomEmetteur : this.data[0]["nomEmetteur"], 
      telephoneEmetteur : this.data[0]["telephoneEmetteur"]
    });
    console.log(this.data);
  }

  async closeModal(){
    await this.modalCtrl.dismiss();
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    return this.router.navigate(['/acceuil']);
  }

  retraitTrans(){
    return this.transactionService.retrait(this.confirmRetrait.value).subscribe(
      res => {
        console.log(res)
      }
    ), this.closeModal(), this.reloadComponent();
  }

}
