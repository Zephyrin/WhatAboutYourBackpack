import { BaseComponent } from '@app/_components/base-component';
import { EquipmentsService } from '@app/_services/equipments/equipments.service';
import { BreakpointObserver } from '@angular/cdk/layout';
import { Component } from '@angular/core';

@Component({
  selector: 'app-equipments',
  templateUrl: './equipments.component.html',
  styleUrls: ['./equipments.component.scss']
})
export class EquipmentsComponent extends BaseComponent {

  constructor(
    protected breakpointObserver: BreakpointObserver,
    public service: EquipmentsService) {
    super(breakpointObserver, service);
  }

}
