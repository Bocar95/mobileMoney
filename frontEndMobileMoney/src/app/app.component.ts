import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {

  public appPages = [
    { title: 'Home', url: '/folder/Home', icon: 'home' },
    { title: 'Transactions', url: '/folder/Transactions', icon: 'time' },
    { title: 'Commissions', url: '/folder/Commissions', icon: 'cash' },
    { title: 'Calculateur', url: '/folder/Calculateur', icon: 'calculator' },
  ];

  constructor() {}

}
