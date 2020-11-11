import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { MatTableDataSource } from '@angular/material/table';
import { ChildCreateFormBaseComponent } from '@app/_components/child-create-form-base-component';
import { RemoveDialogComponent } from '@app/_components/helpers/remove-dialog/remove-dialog.component';
import { MatDialog } from '@angular/material/dialog';
import { MatSort } from '@angular/material/sort';
import { CdkDragDrop, moveItemInArray } from '@angular/cdk/drag-drop';
import { IService, ValueViewChild } from '@app/_services/iservice';
import { Component, OnInit, Input, ViewChild, AfterViewInit } from '@angular/core';
import { animate, state, style, transition, trigger } from '@angular/animations';

@Component({
  selector: 'app-sub-table',
  templateUrl: './sub-table.component.html',
  styleUrls: ['./sub-table.component.scss'],
  animations: [
    trigger('detailExpand', [
      state('collapsed', style({ height: '0px', minHeight: '0' })),
      state('expanded', style({ height: '*' })),
      transition('expanded <=> collapsed', animate('225ms cubic-bezier(0.4, 0.0, 0.2, 1)')),
    ]),
  ],
})
export class SubTableComponent implements OnInit, AfterViewInit {
  @Input() service: IService;
  @Input() allowSelected = false;
  @Input() subTable = undefined;
  @Input() expandedDetailName: string;
  private $source: any;
  public get source(): any {
    return this.$source;
  }
  @Input()
  public set source(source: any) {
    this.$source = source;
  }

  expandedDetail = undefined;
  dataSource: any = [];
  @ViewChild(MatSort) sort: MatSort;
  selected: any | null;
  @Input() componentOrTemplateRef: string;

  constructor(public dialog: MatDialog, private compCreateRegistry: ComponentCreateRegistryService) {
  }

  ngOnInit(): void {
    this.dataSource = new MatTableDataSource(this.$source);
    this.dataSource.sort = this.sort;
  }

  ngAfterViewInit(): void {
    this.dataSource = new MatTableDataSource(this.$source);
    this.dataSource.sort = this.sort;
  }

  dropListDropped(event: CdkDragDrop<ValueViewChild>) {
    if (event) {
      moveItemInArray(this.service.displayedColumns, event.previousIndex, event.currentIndex);
      const elt = this.service.displayedColumns[event.currentIndex];
      const index = this.service.headers.findIndex(x => x.value === elt);
      moveItemInArray(this.service.headers, index, event.currentIndex);
      localStorage.setItem(this.service.constructor.name + '_headers', JSON.stringify(this.service.headers));
    }
  }

  public clickOnRow(row: any): void {
    if (this.allowSelected) {
      this.selected = this.selected?.id === row?.id ? undefined : row;
      this.expandedDetail = this.service.get(this.expandedDetailName, this.selected);
      this.service.selected = this.service.selected?.id === row?.id ? undefined : row;
    }
  }

  openUpdateDialog(evt, element: any): void {
    evt.stopPropagation();
    const dialogRef = this.dialog.open(this.compCreateRegistry.getComponentByName(this.componentOrTemplateRef));
    dialogRef.afterClosed().subscribe(result => {
      if (result) {
      }
    });
    if (dialogRef.componentInstance) {
      (dialogRef.componentInstance as unknown as ChildCreateFormBaseComponent).update(element);
    }
  }

  openDeleteDialog(evt, element: any, title: string): void {
    evt.stopPropagation();
    const dialogRef = this.dialog.open(RemoveDialogComponent);
    (dialogRef.componentInstance as RemoveDialogComponent).title = title;
    dialogRef.afterClosed().subscribe(result => {
      if (result && result.data === true) {
        this.service.update(undefined, element, null);
      }
    });
  }
}
