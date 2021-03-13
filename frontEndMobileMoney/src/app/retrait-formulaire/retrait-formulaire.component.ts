import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TransactionService } from '../services/transactionService/transaction.service';
import { RetraitModalComponent } from '../retrait-modal/retrait-modal.component';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-retrait-formulaire',
  templateUrl: './retrait-formulaire.component.html',
  styleUrls: ['./retrait-formulaire.component.scss'],
})
export class RetraitFormulaireComponent implements OnInit {

  disabledEmetteurInputs = false;
  disabledBeneficiaireInputs = true;
  disabled = true;

  retraitForm : FormGroup;
  codeFormControl = new FormControl('', [Validators.required, Validators.pattern(/((^[0-9]{3})-([0-9]{3})-([0-9]{3}$))/)]);
  nomCompletBeneficiaireFormControl = new FormControl();
  cniBeneficiaireFormControl = new FormControl('', [Validators.required, Validators.pattern(/(^[0-9]{13}$)/)]);
  telephoneBeneficiaireFormControl = new FormControl();
  montantFormControl = new FormControl();
  nomCompletEmetteurFormControl = new FormControl();
  telephoneEmetteurFormControl = new FormControl();

  transInfo = [];
  clientBeneficiaire = [];
  clientEmetteur = [];

  constructor(private router : Router, private transactionService : TransactionService, private modalCtrl : ModalController,private formBuilder : FormBuilder) { }

  ngOnInit() {
    this.retraitForm = this.formBuilder.group({
      codeTrans : this.codeFormControl,
      numCni : this.cniBeneficiaireFormControl,
      nomBeneficiaire : this.nomCompletBeneficiaireFormControl,
      telephone : this.telephoneBeneficiaireFormControl,
      montant : this.montantFormControl
    });    
  }

  getBackHome(){
    return this.router.navigate(['/acceuil']);
  }

  disabledBeneficiaire(){
    if (this.disabledEmetteurInputs == false){
      this.disabledEmetteurInputs = true;
    }
    if (this.disabledBeneficiaireInputs == true){
      this.disabledBeneficiaireInputs = false;
    }
  }

  disabledEmetteur(){
    if (this.disabledEmetteurInputs == true){
      this.disabledEmetteurInputs = false;
    }
    if (this.disabledBeneficiaireInputs == false){
      this.disabledBeneficiaireInputs = true;
    }
  }

  getTransByCode(){
    return this.transactionService.getTransactionByCode(this.codeFormControl.value).subscribe(
      (res:any) => {
        console.log(res),
        this.transInfo = res,
        this.clientBeneficiaire = res["clientRetrait"],
        this.clientEmetteur = res["clientDepot"]        
      }
    )
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    return this.router.navigate(['/acceuil']);
  }

  refresh (){
    this.router.navigateByUrl('/depot', { skipLocationChange: true }).then(() => {
      this.router.navigate(['acceuil']);
    }); 
  }

  async showModal(){
    if(this.retraitForm.valid){
      const modal = await this.modalCtrl.create({
        component : RetraitModalComponent,
        componentProps : {
          data : [this.retraitForm.value, this.clientEmetteur["nomComplet"], this.clientEmetteur["telephone"]]
        },
        cssClass : 'my-modal-component-css'
      })
      await modal.present();
    }
  }

}
