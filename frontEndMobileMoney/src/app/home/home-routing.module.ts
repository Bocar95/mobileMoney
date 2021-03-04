import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AcceuilComponent } from '../acceuil/acceuil.component';
import { DepotFormulaireComponent } from '../depot-formulaire/depot-formulaire.component';
import { AuthGuard } from '../services/authGuardService/auth.guard';
import { HomePage } from './home.page';

const routes: Routes = [
  { path: '', component: HomePage },
  { path : 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path : 'depot', component: DepotFormulaireComponent, canActivate: [AuthGuard] }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomePageRoutingModule {}
