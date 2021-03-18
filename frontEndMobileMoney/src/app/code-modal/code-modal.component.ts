import { Location } from '@angular/common';
import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ModalController, NavController } from '@ionic/angular';

@Component({
  selector: 'app-code-modal',
  templateUrl: './code-modal.component.html',
  styleUrls: ['./code-modal.component.scss'],
})
export class CodeModalComponent implements OnInit {

  @Input() data;

  codeTrans;
  nomBeneficiaire;
  date;
  montant;

  constructor(private router: Router, private modalCtrl : ModalController, private navCtrl : NavController, private location : Location) { }

  ngOnInit() {
    this.codeTrans = this.data[0]["codeTrans"];
    this.date = this.data[0]["dateDepot"];
    this.montant = this.data[0]["montant"];
    this.nomBeneficiaire = this.data[1];
  }

  async closeModal(){
    await this.modalCtrl.dismiss();
  }

  sendSms() {
   return  this.closeModal(), this.router.navigate(['/depot']);
  }

}
