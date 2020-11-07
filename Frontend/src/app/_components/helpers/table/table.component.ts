import { ComponentCreateRegistryService } from '@app/_services/component-create-registry.service';
import { MatDialog } from '@angular/material/dialog';
import { ChildBaseComponent } from '@app/_components/child-base-component';
import { ValueViewChild } from '@app/_services/iservice';
import { MatSort } from '@angular/material/sort';
import { Component, OnInit, Input, ViewChild, AfterViewInit } from '@angular/core';
import { merge } from 'rxjs';
import { tap } from 'rxjs/operators';
import { MatTableDataSource } from '@angular/material/table';
import { CdkDragDrop, moveItemInArray } from '@angular/cdk/drag-drop';
import { animate, state, style, transition, trigger } from '@angular/animations';

@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.scss'],
  animations: [
    trigger('detailExpand', [
      state('collapsed', style({ height: '0px', minHeight: '0' })),
      state('expanded', style({ height: '*' })),
      transition('expanded <=> collapsed', animate('225ms cubic-bezier(0.4, 0.0, 0.2, 1)')),
    ]),
  ],
})
export class TableComponent extends ChildBaseComponent implements OnInit, AfterViewInit {
  @Input() allowSelected = false;
  @Input() subTable = undefined;
  @Input() expandedDetailName: string;
  expandedDetail = undefined;
  dataSource: any = [];
  @ViewChild(MatSort) sort: MatSort;
  selected: any | null;

  constructor(
    public dialog: MatDialog, private createRegistry: ComponentCreateRegistryService) {
    super(dialog, createRegistry);
  }

  ngOnInit(): void {
    this.dataSource.sort = this.sort;
  }

  ngAfterViewInit(): void {
    merge(this.sort.sortChange)
      .pipe(tap(() => {
        this.service.sort.change(this.sort.active, this.sort.direction);
      })).subscribe();
  }

  public endUpdate() {
    this.dataSource = new MatTableDataSource(this.service.model);
    const index = this.service.displayedColumns.findIndex(x => x === 'action');
    if (index < 0) {
      this.service.displayedColumns.push('action');
    }
    else if (index < this.service.displayedColumns.length - 1) {
      moveItemInArray(this.service.displayedColumns, index, this.service.displayedColumns.length - 1);
    }
    this.dataSource.sort = this.sort;
  }

  dropListDropped(event: CdkDragDrop<ValueViewChild>) {
    if (event) {
      moveItemInArray(this.service.displayedColumns, event.previousIndex, event.currentIndex);
      const elt = this.service.displayedColumns[event.currentIndex];
      const index = this.service.headers.findIndex(x => x.value === elt);
      moveItemInArray(this.service.headers, index, event.currentIndex);
      localStorage.setItem(this.service.constructor.name + '_headers', JSON.stringify(this.service.headers));
      this.endUpdate();
    }
  }

  public clickOnRow(row: any): void {
    if (this.allowSelected) {
      this.selected = this.selected === row ? undefined : row;
      this.expandedDetail = this.service.get(this.expandedDetailName, this.selected);
      this.service.selected = this.service.selected === row ? undefined : row;
    }
  }
}
