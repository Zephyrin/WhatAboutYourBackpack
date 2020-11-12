import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { MatDialog } from '@angular/material/dialog';
import { Component } from '@angular/core';

@Component({
  selector: 'app-equipments-mobile',
  templateUrl: './equipments-mobile.component.html',
  styleUrls: ['./equipments-mobile.component.scss']
})
export class EquipmentsMobileComponent extends ChildBaseComponent {
  constructor(public dialog: MatDialog, private createRegistry: ComponentCreateRegistryService) {
    super(dialog, createRegistry);
  }
}
