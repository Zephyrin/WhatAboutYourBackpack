import { FormBuilder } from '@angular/forms';
import { EquipmentsService } from '@app/_services/equipments/equipments.service';
import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { MatDialog } from '@angular/material/dialog';
import { TableComponent } from '@app/_components/helpers/table/table.component';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { Component, ViewChild, ElementRef } from '@angular/core';

@Component({
  selector: 'app-equipments-desktop',
  templateUrl: './equipments-desktop.component.html',
  styleUrls: ['./equipments-desktop.component.scss']
})
export class EquipmentsDesktopComponent extends ChildBaseComponent {
  @ViewChild('Table') tableComponent: TableComponent;
  get equipmentService(): EquipmentsService { return this.service as EquipmentsService; }
  constructor(public dialog: MatDialog, private createRegistry: ComponentCreateRegistryService, private fb: FormBuilder) {
    super(dialog, createRegistry);

  }

  public endUpdate() {
    this.tableComponent.endUpdate();
  }

  public init() {
    this.equipmentService.createFormCharacteristic(this.fb);
  }
}
