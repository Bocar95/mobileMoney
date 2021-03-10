import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Component, Input, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { TransactionService } from '../services/transactionService/transaction.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-depot-modal',
  templateUrl: './depot-modal.component.html',
  styleUrls: ['./depot-modal.component.scss'],
})
export class DepotModalComponent implements OnInit {

  @Input() data:any;

  confirmDepot : FormGroup;

  constructor(private modalCtrl : ModalController, private formBuilder : FormBuilder, private transactionService : TransactionService, private router : Router) { }

  ngOnInit() {
    this.confirmDepot  =  this.formBuilder.group({
      nomCompletEmetteur : this.data[0]["nomCompletEmetteur"],
      numCniEmetteur : this.data[0]["numCniEmetteur"],
      telephoneEmetteur: this.data[0]["telephoneEmetteur"],
      nomCompletBeneficiaire : this.data[0]["nomCompletBeneficiaire"],
      telephoneBeneficiaire : this.data[0]["telephoneBeneficiaire"],
      montant : this.data[0]["montant"]
    });
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

  depot() {
    return this.transactionService.addDepot(this.confirmDepot.value).subscribe(
      res => {
        console.log(res)
      }
    ), this.reloadComponent();
  }
}
