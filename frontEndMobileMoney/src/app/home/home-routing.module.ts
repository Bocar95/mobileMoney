import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdminComponent } from '../admin/admin.component';
import { AuthGuard } from '../services/authGuardService/auth.guard';
import { HomePage } from './home.page';

const routes: Routes = [
  { path: '', component: HomePage },
  { path : 'admin', component: AdminComponent, canActivate: [AuthGuard] }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomePageRoutingModule {}
