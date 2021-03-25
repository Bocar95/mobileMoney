import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {

  public appPages = [
    { title: 'Home', url: '/acceuil', icon: 'home' },
    { title: 'Transactions', url: '/myTransactions', icon: 'time' },
    { title: 'Commissions', url: '/commissions', icon: 'cash' },
    { title: 'Calculateur', url: '/fraisCalculator', icon: 'calculator' },
  ];

  constructor() {}

}
