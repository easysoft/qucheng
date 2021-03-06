/*
Copyright 2022.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/
// Code generated by lister-gen. DO NOT EDIT.

package v1beta1

import (
	"k8s.io/apimachinery/pkg/api/errors"
	"k8s.io/apimachinery/pkg/labels"
	"k8s.io/client-go/tools/cache"

	v1beta1 "gitlab.zcorp.cc/pangu/cne-api/apis/qucheng/v1beta1"
)

// DbLister helps list Dbs.
// All objects returned here must be treated as read-only.
type DbLister interface {
	// List lists all Dbs in the indexer.
	// Objects returned here must be treated as read-only.
	List(selector labels.Selector) (ret []*v1beta1.Db, err error)
	// Dbs returns an object that can list and get Dbs.
	Dbs(namespace string) DbNamespaceLister
	DbListerExpansion
}

// dbLister implements the DbLister interface.
type dbLister struct {
	indexer cache.Indexer
}

// NewDbLister returns a new DbLister.
func NewDbLister(indexer cache.Indexer) DbLister {
	return &dbLister{indexer: indexer}
}

// List lists all Dbs in the indexer.
func (s *dbLister) List(selector labels.Selector) (ret []*v1beta1.Db, err error) {
	err = cache.ListAll(s.indexer, selector, func(m interface{}) {
		ret = append(ret, m.(*v1beta1.Db))
	})
	return ret, err
}

// Dbs returns an object that can list and get Dbs.
func (s *dbLister) Dbs(namespace string) DbNamespaceLister {
	return dbNamespaceLister{indexer: s.indexer, namespace: namespace}
}

// DbNamespaceLister helps list and get Dbs.
// All objects returned here must be treated as read-only.
type DbNamespaceLister interface {
	// List lists all Dbs in the indexer for a given namespace.
	// Objects returned here must be treated as read-only.
	List(selector labels.Selector) (ret []*v1beta1.Db, err error)
	// Get retrieves the Db from the indexer for a given namespace and name.
	// Objects returned here must be treated as read-only.
	Get(name string) (*v1beta1.Db, error)
	DbNamespaceListerExpansion
}

// dbNamespaceLister implements the DbNamespaceLister
// interface.
type dbNamespaceLister struct {
	indexer   cache.Indexer
	namespace string
}

// List lists all Dbs in the indexer for a given namespace.
func (s dbNamespaceLister) List(selector labels.Selector) (ret []*v1beta1.Db, err error) {
	err = cache.ListAllByNamespace(s.indexer, s.namespace, selector, func(m interface{}) {
		ret = append(ret, m.(*v1beta1.Db))
	})
	return ret, err
}

// Get retrieves the Db from the indexer for a given namespace and name.
func (s dbNamespaceLister) Get(name string) (*v1beta1.Db, error) {
	obj, exists, err := s.indexer.GetByKey(s.namespace + "/" + name)
	if err != nil {
		return nil, err
	}
	if !exists {
		return nil, errors.NewNotFound(v1beta1.Resource("db"), name)
	}
	return obj.(*v1beta1.Db), nil
}
