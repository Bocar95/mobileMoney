import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ModalController } from '@ionic/angular';
import { DepotModalComponent } from '../depot-modal/depot-modal.component';
import { ClientService } from '../services/clientsService/client.service';
import { TransactionService } from '../services/transactionService/transaction.service';

@Component({
  selector: 'app-depot-formulaire',
  templateUrl: './depot-formulaire.component.html',
  styleUrls: ['./depot-formulaire.component.scss'],
})
export class DepotFormulaireComponent implements OnInit {

  disabledEmetteurInputs = false;
  disabledBeneficiaireInputs = true;
  hiddenForModal = true;
  hiddenForNext = false;
  disabled = false;
  clientEmetteur = [];

  frais = 0;
  total = 0;

  depotForm: FormGroup;
  cniEmetteurFormControl = new FormControl('', [Validators.required, Validators.pattern(/(^[0-9]{13}$)/)]);
  nomCompletEmetteurFormControl = new FormControl('', [Validators.required, Validators.pattern(/(^[A-Z]{1}([a-zA-Z]))/) ]);
  telephoneEmetteurFormControl = new FormControl('', [Validators.required, Validators.pattern(/((\+221|00221)?)((7[7608][0-9]{7}$)|(3[03][98][0-9]{6}$))/)]);
  nomCompletBeneficiaireFormControl = new FormControl('', [Validators.required, Validators.pattern(/(^[A-Z]{1}([a-zA-Z]))/)]);
  telephoneBeneficiaireFormControl = new FormControl('', [Validators.required, Validators.pattern(/((\+221|00221)?)((7[7608][0-9]{7}$)|(3[03][98][0-9]{6}$))/)]);
  montantFormControl = new FormControl('', [Validators.required, Validators.pattern(/(^[0-9])/)]);

  constructor(private modalCtrl : ModalController,private formBuilder: FormBuilder, private router: Router, private transactionService : TransactionService, private clientService : ClientService) { }

  ngOnInit() {
    this.depotForm  =  this.formBuilder.group({
      numCniEmetteur : this.cniEmetteurFormControl,
      nomCompletEmetteur : this.nomCompletEmetteurFormControl,
      telephoneEmetteur: this.telephoneEmetteurFormControl,
      nomCompletBeneficiaire : this.nomCompletBeneficiaireFormControl,
      telephoneBeneficiaire : this.telephoneBeneficiaireFormControl,
      montant : this.montantFormControl
    });
  }

  getBackHome(){
    return this.router.navigate(['/acceuil']);
  }

  disabledBeneficiaire(){
    this.disabledEmetteurInputs = false;
    this.disabledBeneficiaireInputs = true;
    // this.disabled = true;
    this.hiddenForModal = true;
    this.hiddenForNext = false;
  }

  disabledEmetteur(){
    this.disabledBeneficiaireInputs = false;
    this.disabledEmetteurInputs = true;
    this.hiddenForModal = false;
    this.hiddenForNext = true;
    if(this.depotForm.valid){
      this.disabled = false;
    }else
      if(this.depotForm.invalid){
        this.disabled = true;
    }
  }

  fraisCalculator (){
    var montant = +this.montantFormControl.value;
    return this.transactionService.getFrais(montant).subscribe(
        (data : number) => {
          this.frais = data,
          console.log(data,montant)
        }
      );
  }

  totalToGive(){
    return this.total = +this.frais + +this.montantFormControl.value;
  }

  nextPage(){
    this.disabledBeneficiaireInputs = false;
    this.disabledEmetteurInputs = true;
    this.hiddenForNext = true;
    this.hiddenForModal = false;
    if(this.depotForm.valid){
      this.disabled = false;
    }else
      if(this.depotForm.invalid){
        this.disabled = true;
    }
  }

  async showModal(){
    if (this.depotForm.valid){
      this.disabled = false;
      const modal = await this.modalCtrl.create({
        component : DepotModalComponent,
        componentProps : {
          data : [this.depotForm.value]
        },
        cssClass : 'my-modal-component-css'
      })
      await modal.present();
    }else{
      this.disabled = true;
    }
  }

  getClient(){
    return this.clientService.getClientByCni(this.cniEmetteurFormControl.value).subscribe(
      (res:any) => {
        console.log(res),
        this.clientEmetteur = res
      }
    )
  }

}
