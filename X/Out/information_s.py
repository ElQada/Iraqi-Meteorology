import models.main as model_main

class Information_s(model_main.SQLModel, table=True):

    s__id: model_main.Optional[int]          = model_main.Field(default=None, primary_key=True, description="ID")

    table_name: str                          = model_main.Field(...,max_length=32,description="Table name")

    title: str                               = model_main.Field(...,max_length=255,description="Title")
    description: model_main.Optional[str]    = model_main.Field(default=None, nullable=True,max_length=255,description="Description")

    s__created_at: model_main.Optional[model_main.datetime]  = model_main.Field(default=None, nullable=True,description="Created at")
    s__updated_at: model_main.Optional[model_main.datetime]  = model_main.Field(default=None, nullable=True,description="Updated at")
    s__deleted_at: model_main.Optional[model_main.datetime]  = model_main.Field(default=None, nullable=True,description="Deleted at")

    #s__users: model_main.Optional[int] =  model_main.Field(default=None, nullable=True, foreign_key='users.s__id',description="Foreign__users")

    #__table_args__ = ( model_main.UniqueConstraint("table_name","key_tag", name="table_name__key_tag"),)