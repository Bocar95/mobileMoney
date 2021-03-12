import { Component, Input, OnInit } from '@angular/core';

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

  constructor() { }

  ngOnInit() {
    this.codeTrans = this.data[0]["codeTrans"];
    this.date = this.data[0]["dateDepot"];
    this.montant = this.data[0]["montant"];
    this.nomBeneficiaire = this.data[1];

  }

}
